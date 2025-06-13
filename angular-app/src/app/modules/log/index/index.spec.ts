import { ComponentFixture, TestBed } from '@angular/core/testing';

import { IndexLog } from './index';

describe('Index', () => {
  let component: IndexLog;
  let fixture: ComponentFixture<IndexLog>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [IndexLog],
    }).compileComponents();

    fixture = TestBed.createComponent(IndexLog);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
